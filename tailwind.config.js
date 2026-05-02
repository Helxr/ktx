import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbitePlugin from 'flowbite/plugin';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    emerald: 'oklch(var(--brand-emerald-lch) / <alpha-value>)',
                    jade: 'oklch(var(--brand-jade-lch) / <alpha-value>)',
                },
                ui: {
                    bg: 'oklch(var(--ui-bg-lch) / <alpha-value>)',
                    card: 'oklch(var(--ui-card-lch) / <alpha-value>)',
                    border: 'oklch(var(--ui-border-lch) / <alpha-value>)',
                    muted: 'oklch(var(--ui-muted-lch) / <alpha-value>)',
                },
                ink: {
                    primary: 'oklch(var(--ink-primary-lch) / <alpha-value>)',
                    secondary: 'oklch(var(--ink-secondary-lch) / <alpha-value>)',
                },
                status: {
                    success: 'oklch(var(--success-lch) / <alpha-value>)',
                    warning: 'oklch(var(--warning-lch) / <alpha-value>)',
                    error: 'oklch(var(--error-lch) / <alpha-value>)',
                },
            },
            fontFamily: {
                sans: ['Onest', ...defaultTheme.fontFamily.sans],
                display: ['Bricolage Grotesque', ...defaultTheme.fontFamily.sans],
            },
            letterSpacing: {
                tight: '-0.01em',
                tighter: '-0.04em',
            },
            boxShadow: {
                soft: '0 10px 30px rgb(15 23 42 / 0.06)',
                float: '0 20px 55px rgb(5 150 105 / 0.16)',
                glass: '0 10px 30px rgb(15 23 42 / 0.08), inset 0 1px 0 rgb(255 255 255 / 0.55)',
            },
            backdropBlur: {
                glass: '12px',
            },
            transitionTimingFunction: {
                smooth: 'cubic-bezier(0.22, 1, 0.36, 1)',
            },
            keyframes: {
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'pop-in': {
                    '0%': { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
            },
            animation: {
                'fade-up': 'fade-up 320ms ease-out both',
                'pop-in': 'pop-in 220ms ease-out both',
                'soft-pulse': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
        },
    },

    plugins: [forms, flowbitePlugin],
};
