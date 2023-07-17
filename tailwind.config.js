/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "*.{html,js,twig}",
      "templates/*.{html,js,twig}",
      "./node_modules/flowbite/**/*.js",
    ],
    theme: {
      extend: {
        colors: {
          "blue-100": "#1D5F6B",
          "blue-200": "#18515C",
          "blue-300": "#11373F",
          "corail-100": "#F7645D",
          "corail-200": "#EC5052",
          "corail-300": "#BD3E43",
          "corail-50": "#F2C5B5",
          "nude-100": "#F0E5D3",
          "nude-200": "#E9DBC1",
          "nude-300": "#DCCDB6",
          "gris-100": "#3E3943",
          "gris-200": "#2E2B31",
          "gris-300": "#1D1923",
        },
        lineHeight: {
          "H1-52px": "52px",
          12: "3rem",
        },
        height: {
          166: "166px",
        },
        width: {
          158: "158px",
          197: "197px",
        },
        fontSize: {
          title: "180px",
          subTitle: "40px",
        },
        backgroundImage: {
          'fil_ariane': "url('/images/fil/fil_mobile_blanc_1.svg')",
        }
      },
      fontFamily: {
        Jost: ["Jost"],
        title: ["Neue Machina"],
      },
      screens: {
        xl: "1100px",
        md: "768px",
        lg: "1100px"
      }
    },
    plugins: [require('flowbite/plugin.js')],
  };