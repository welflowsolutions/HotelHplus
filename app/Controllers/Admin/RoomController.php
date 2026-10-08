<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class RoomController extends BaseController
{
    private const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
    private const ALLOWED_IMAGE_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
    private const MAX_IMAGE_SIZE_BYTES = 5 * 1024 * 1024;

    private const STARTER_ROOMS = [
        [
            'name'        => 'Deluxe Room',
            'slug'        => 'deluxe',
            'description' => 'A comfortable room for solo travellers and couples with king bed, AC, Smart TV, Wi-Fi, attached bathroom, and convenient hotel access.',
            'price'       => '1800.00',
            'max_guests'  => 2,
            'available_units' => 1,
            'amenities'   => ['King Bed', 'Air Conditioning', 'Smart TV', 'Free Wi-Fi', 'Attached Bathroom', 'Hot & Cold Water', 'Toiletries', 'Free Parking'],
            'image'       => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1800&q=85',
            'gallery_images' => [
                'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1800&q=85',
                'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=1000&q=85',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&q=85',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&q=85',
            ],
            'sort_order'  => 1,
        ],
        [
            'name'        => 'Super Deluxe Room',
            'slug'        => 'super-deluxe',
            'description' => 'An upgraded stay with added space, premium furnishings, plush bedding, modern bathroom, and all the essentials for a more relaxed stay.',
            'price'       => '2200.00',
            'max_guests'  => 2,
            'available_units' => 1,
            'amenities'   => ['Premium King Bed', 'Air Conditioning', 'Smart TV', 'Free Wi-Fi', 'Attached Bathroom', 'Wardrobe', 'Toiletries', 'Room Service'],
            'image'       => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1800&q=85',
            'gallery_images' => [
                'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1800&q=85',
                'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=1000&q=85',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&q=85',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&q=85',
            ],
            'sort_order'  => 2,
        ],
        [
            'name'        => 'Executive Room',
            'slug'        => 'executive',
            'description' => 'A spacious premium room designed for families, business travellers, and guests who want more comfort, more room, and a more elevated stay.',
            'price'       => '3000.00',
            'max_guests'  => 3,
            'available_units' => 1,
            'amenities'   => ['Luxury King Bed', 'Air Conditioning', 'Smart TV', 'Free Wi-Fi', 'Premium Bathroom', 'Seating Area', 'Tea Setup', 'Free Parking'],
            'image'       => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=1800&q=85',
            'gallery_images' => [
                'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=1800&q=85',
                'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=1000&q=85',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&q=85',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&q=85',
            ],
            'sort_order'  => 3,
        ],
    ];

    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);
        return view('admin/layouts/app', $data);
    }

    private function db()
    {
        return \Config\Database::connect();
    }

    private function mediaFiles(): array
    {
        return $this->db()->tableExists('media_files')
            ? (new MediaController())->mediaFiles()
            : [];
    }

    private function normalizeGalleryImages(?string $value): array
    {
        $decoded = json_decode((string) $value, true);

        if (! is_array($decoded)) {
            return [];
        }

        return array_values(array_filter(array_map(
            static fn ($item): string => trim((string) $item),
            $decoded
        )));
    }

    private function uploadRoomImage($file): ?string
    {
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        $extension = strtolower((string) $file->getClientExtension());
        $mimeType = (string) $file->getMimeType();

        if (
            ! in_array($extension, self::ALLOWED_IMAGE_EXTENSIONS, true)
            || ! in_array($mimeType, self::ALLOWED_IMAGE_MIME_TYPES, true)
            || $file->getSize() > self::MAX_IMAGE_SIZE_BYTES
        ) {
            throw new \RuntimeException('Please upload a valid JPG, PNG, GIF, WebP, or AVIF image up to 5 MB.');
        }

        $targetPath = FCPATH . 'uploads/rooms';

        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0775, true);
        }

        $newName = $file->getRandomName();
        $file->move($targetPath, $newName);
        $relativePath = 'uploads/rooms/' . $newName;

        if (@getimagesize(FCPATH . $relativePath) === false) {
            @unlink(FCPATH . $relativePath);
            throw new \RuntimeException('The uploaded room file is not a readable image.');
        }

        return $relativePath;
    }

    private function roomAuditSnapshot(array $room): array
    {
        return [
            'name' => (string) ($room['name'] ?? ''),
            'slug' => (string) ($room['slug'] ?? ''),
            'price' => (string) ($room['price'] ?? ''),
            'max_guests' => (string) ($room['max_guests'] ?? ''),
            'available_units' => (string) ($room['available_units'] ?? '1'),
            'image' => (string) ($room['image'] ?? ''),
            'is_active' => (string) ($room['is_active'] ?? ''),
            'booking_open' => (string) ($room['booking_open'] ?? ''),
            'sort_order' => (string) ($room['sort_order'] ?? ''),
        ];
    }

    private function roomAuditChanges(array $before, array $after): array
    {
        $changes = [];
        $before = $this->roomAuditSnapshot($before);
        $after = $this->roomAuditSnapshot($after);

        foreach ($after as $key => $value) {
            if (($before[$key] ?? '') === $value) {
                continue;
            }

            $changes[$key] = [
                'old' => $before[$key] ?? '',
                'new' => $value,
            ];
        }

        return $changes;
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessRoomsAllowed()) {
            return $redirect;
        }

        $rooms = $this->db()
            ->table('rooms')
            ->orderBy('sort_order', 'ASC')
            ->get()->getResultArray();

        return $this->render('admin/rooms/index', [
            'title' => 'Rooms',
            'page'  => 'rooms',
            'rooms' => $rooms,
        ]);
    }

    public function importStarterRooms()
    {
        if ($redirect = $this->denyUnlessRoomsAllowed()) {
            return $redirect;
        }

        $table = $this->db()->table('rooms');
        $existingSlugs = array_column(
            $table->select('slug')->get()->getResultArray(),
            'slug'
        );

        $inserted = 0;
        $insertedRooms = [];
        $now = date('Y-m-d H:i:s');

        foreach (self::STARTER_ROOMS as $room) {
            if (in_array($room['slug'], $existingSlugs, true)) {
                continue;
            }

            $insertData = [
                'name'        => $room['name'],
                'slug'        => $room['slug'],
                'description' => $room['description'],
                'price'       => $room['price'],
                'max_guests'  => $room['max_guests'],
                'available_units' => (int) ($room['available_units'] ?? 1),
                'amenities'   => json_encode($room['amenities']),
                'image'       => $room['image'] ?? null,
                'gallery_images' => json_encode($room['gallery_images'] ?? []),
                'is_active'   => 1,
                'booking_open'=> 1,
                'sort_order'  => $room['sort_order'],
                'created_at'  => $now,
                'updated_at'  => $now,
            ];

            $table->insert($insertData);

            $inserted++;
            $insertedRooms[] = [
                'id' => (int) $this->db()->insertID(),
                'name' => $room['name'],
                'slug' => $room['slug'],
            ];
        }

        if ($inserted === 0) {
            return redirect()->to(base_url('admin/rooms'))->with('success', 'Starter rooms are already imported.');
        }

        Services::auditLogger()->log('room.imported', 'room', null, $inserted . ' starter room' . ($inserted > 1 ? 's' : '') . ' imported', [
            'count' => $inserted,
            'rooms' => $insertedRooms,
        ]);

        return redirect()->to(base_url('admin/rooms'))->with('success', $inserted . ' starter room' . ($inserted > 1 ? 's' : '') . ' imported successfully.');
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessRoomsAllowed()) {
            return $redirect;
        }

        return $this->render('admin/rooms/form', [
            'title' => 'Add Room',
            'page'  => 'rooms',
            'room'  => null,
            'mediaFiles' => $this->mediaFiles(),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->denyUnlessRoomsAllowed()) {
            return $redirect;
        }

        $rules = [
            'name'  => 'required|min_length[3]',
            'price' => 'required|numeric',
            'slug'  => 'required|alpha_dash',
            'available_units' => 'permit_empty|integer|greater_than[0]|less_than_equal_to[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/rooms/create'))->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'max_guests'  => $this->request->getPost('max_guests') ?? 2,
            'available_units' => max(1, (int) ($this->request->getPost('available_units') ?? 1)),
            'amenities'   => json_encode(array_filter(explode("\n", $this->request->getPost('amenities') ?? ''))),
            'gallery_images' => json_encode($this->normalizeGalleryImages($this->request->getPost('gallery_images'))),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
            'booking_open'=> $this->request->getPost('booking_open') ? 1 : 0,
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $selectedImagePath = trim((string) $this->request->getPost('image_path'));
        if ($selectedImagePath !== '') {
            $data['image'] = $selectedImagePath;
        }

        try {
            $uploadedImage = $this->uploadRoomImage($this->request->getFile('image'));
        } catch (\RuntimeException $e) {
            return redirect()->to(base_url('admin/rooms/create'))->withInput()->with('error', $e->getMessage());
        }

        if ($uploadedImage !== null) {
            $data['image'] = $uploadedImage;
        }

        $this->db()->table('rooms')->insert($data);
        $roomId = (int) $this->db()->insertID();

        Services::auditLogger()->log('room.created', 'room', $roomId, 'Room created: ' . (string) $data['name'], [
            'changed_keys' => array_keys($this->roomAuditSnapshot($data)),
            'room' => $this->roomAuditSnapshot($data),
        ]);

        return redirect()->to(base_url('admin/rooms'))->with('success', 'Room added successfully.');
    }

    public function edit(int $id): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessRoomsAllowed()) {
            return $redirect;
        }

        $room = $this->db()->table('rooms')->where('id', $id)->get()->getRowArray();
        if (! $room) return redirect()->to(base_url('admin/rooms'))->with('error', 'Room not found.');

        return $this->render('admin/rooms/form', [
            'title' => 'Edit Room',
            'page'  => 'rooms',
            'room'  => $room,
            'mediaFiles' => $this->mediaFiles(),
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->denyUnlessRoomsAllowed()) {
            return $redirect;
        }

        $existing = $this->db()->table('rooms')->where('id', $id)->get()->getRowArray();

        if (! $existing) {
            return redirect()->to(base_url('admin/rooms'))->with('error', 'Room not found.');
        }

        $rules = [
            'name'  => 'required|min_length[3]',
            'price' => 'required|numeric',
            'slug'  => 'required|alpha_dash',
            'available_units' => 'permit_empty|integer|greater_than[0]|less_than_equal_to[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/rooms/edit/' . $id))->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'max_guests'  => $this->request->getPost('max_guests') ?? 2,
            'available_units' => max(1, (int) ($this->request->getPost('available_units') ?? 1)),
            'amenities'   => json_encode(array_filter(explode("\n", $this->request->getPost('amenities') ?? ''))),
            'gallery_images' => json_encode($this->normalizeGalleryImages($this->request->getPost('gallery_images'))),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
            'booking_open'=> $this->request->getPost('booking_open') ? 1 : 0,
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $selectedImagePath = trim((string) $this->request->getPost('image_path'));
        if ($this->request->getPost('image_path') !== null) {
            $data['image'] = $selectedImagePath !== '' ? $selectedImagePath : null;
        }

        try {
            $uploadedImage = $this->uploadRoomImage($this->request->getFile('image'));
        } catch (\RuntimeException $e) {
            return redirect()->to(base_url('admin/rooms/edit/' . $id))->withInput()->with('error', $e->getMessage());
        }

        if ($uploadedImage !== null) {
            $data['image'] = $uploadedImage;
        }

        $this->db()->table('rooms')->where('id', $id)->update($data);
        $updated = $this->db()->table('rooms')->where('id', $id)->get()->getRowArray() ?: $data;
        $changes = $this->roomAuditChanges($existing, $updated);

        if ($changes !== []) {
            Services::auditLogger()->log('room.updated', 'room', $id, 'Room updated: ' . (string) ($updated['name'] ?? $data['name']), [
                'changed_keys' => array_keys($changes),
                'changes' => $changes,
            ]);
        }

        return redirect()->to(base_url('admin/rooms'))->with('success', 'Room updated successfully.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->denyUnlessRoomsAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->canDeleteData()) {
            return redirect()->to(base_url('admin/rooms'))->with('error', 'Only owner users can delete records.');
        }

        $room = $this->db()->table('rooms')->where('id', $id)->get()->getRowArray();

        if (! $room) {
            return redirect()->to(base_url('admin/rooms'))->with('error', 'Room not found.');
        }

        $this->db()->table('rooms')->where('id', $id)->delete();

        Services::auditLogger()->log('room.deleted', 'room', $id, 'Room deleted: ' . (string) ($room['name'] ?? ('#' . $id)), [
            'room' => $this->roomAuditSnapshot($room),
        ]);

        return redirect()->to(base_url('admin/rooms'))->with('success', 'Room deleted.');
    }

    private function denyUnlessRoomsAllowed(): ?RedirectResponse
    {
        if (Services::adminPermissions()->can('rooms.manage')) {
            return null;
        }

        return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
    }
}
