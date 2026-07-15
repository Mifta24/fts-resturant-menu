import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                'amber-flame': '#f06413',
                'honey-glow': '#feab30',
                'signal-blue': '#0088ff',
                'bright-blue': '#1c95ff',
                'pure-white': '#ffffff',
                'snow-gray': '#f5f5f7',
                mist: '#f0f0f0',
                silver: '#d0d0d3',
                pewter: '#ababb0',
                smoke: '#6e6e73',
                charcoal: '#272727',
                ink: '#101010',
                'true-black': '#000000',
                'vivid-green': '#34c759',
                'electric-magenta': '#cb30e0',
                'alert-red': '#ff383c',
            },

            backgroundImage: {
                'amber-flame': 'linear-gradient(0deg, rgb(240, 100, 19) -29.375%, rgb(254, 171, 48) 100%)',
            },

            fontSize: {
                caption: ['14px', { lineHeight: '18px', letterSpacing: '-0.41px' }],
                body: ['16px', { lineHeight: '24px' }],
                subheading: ['18px', { lineHeight: '24px' }],
                'heading-sm': ['22px', { lineHeight: '28px' }],
                heading: ['40px', { lineHeight: '44px', letterSpacing: '-0.24px' }],
                'heading-lg': ['54px', { lineHeight: '56px', letterSpacing: '-0.7px' }],
                display: ['80px', { lineHeight: '80px', letterSpacing: '-1.04px' }],
            },

            spacing: {
                4.5: '18px',
                13: '52px',
                15: '60px',
                17: '68px',
                18: '72px',
                25: '100px',
                35: '140px',
            },

            borderRadius: {
                card: '20px',
                pill: '100px',
                container: '32px',
            },

            boxShadow: {
                ambient: 'rgba(16, 16, 16, 0.1) 0px 0px 30px 0px',
            },

            maxWidth: {
                page: '1200px',
            },
        },
    },

    plugins: [forms],
};
