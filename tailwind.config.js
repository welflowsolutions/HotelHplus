module.exports = {
  content: [
    './app/Views/front/**/*.php',
    './app/Views/front/layouts/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        display: ['Cormorant Garamond', 'serif'],
        body: ['DM Sans', 'sans-serif'],
      },
      colors: {
        gold: { DEFAULT: '#B8962E', light: '#D4AE50', dark: '#8C7022', pale: '#F5EDD6' },
        ink: { DEFAULT: '#111010', 900: '#1A1A18', 800: '#252520', 700: '#3A3A34' },
        ivory: { DEFAULT: '#FAF8F4', 100: '#F5F0E8', 200: '#EDE5D8' },
      },
      letterSpacing: { luxury: '0.25em' },
    },
  },
  plugins: [],
};
