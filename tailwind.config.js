/** @type {import('tailwindcss').Config} */ 
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      keyframes: {
        slideIn: {
          '0%': {
            opacity: '0',
            transform: 'translateX(100%)',
          },
          '100%': {
            opacity: '1',
            transform: 'translateX(0)',
          },
        },
        fadeOut: {
          '0%': {
            opacity: '1',
            transform: 'translateX(0)',
          },
          '100%': {
            opacity: '0',
            transform: 'translateX(100%)',
          },
        },
      },
      animation: {
        slideIn: 'slideIn 0.5s ease-out forwards',
        fadeOut: 'fadeOut 0.5s ease-in forwards',
      },
    },
  },
  plugins: [],
}
