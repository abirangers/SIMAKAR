import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            // colors: {
            //     primary: "#007bff",
            //     secondary: "#6c757d",
            //     success: "#28a745",
            //     info: "#17a2b8",
            //     warning: "#ffc107",
            //     danger: "#dc2626",
            // },
        },
    },

    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["light"],
                    primary: "#3b82f6", // Blue 500
                    "primary-focus": "#2563eb", // Blue 600
                    "primary-content": "#ffffff",
                    secondary: "#60a5fa", // Blue 400
                    accent: "#93c5fd", // Blue 300
                    neutral: "#1e3a8a", // Blue 900
                    "base-100": "#eff6ff", // Blue 50
                },
            },
        ],
    },

    plugins: [forms, require("@tailwindcss/typography"), require("daisyui")],
};
