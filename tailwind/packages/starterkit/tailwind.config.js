/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin');

module.exports = {
	darkMode: 'class',
	content: ['node_modules/preline/dist/*.js', './src/**/*.html'],

	theme: {
		fontFamily: {
			sans: ['Plus Jakarta Sans', 'sans-serif'],
		},
		extend: {
			boxShadow: {
				'md': 'rgba(145, 158, 171, 0.2) 0px 0px 2px 0px, rgba(145, 158, 171, 0.12) 0px 12px 24px -4px',
				'dark-md': 'rgba(145, 158, 171, 0.3) 0px 0px 2px 0px, rgba(145, 158, 171, 0.02) 0px 12px 24px -4px',
				'sm': '0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)'
			},
			borderRadius: {
				sm: "4px",
				md: "7px",
			},
			container: {
				center: true,
				padding: '20px',
			},
			fontSize: {
				"fs_21": "21px",
				"fs_28": "28px",
				"fs_12": "12px",
				"fs_10": "10px",
				"fs_13": "13px",
			},

			colors: {

				//Light Colors Variables
				primary: "var(--color-primary)",
				secondary: "var(--color-secondary)",
				info: "var(--color-info)",
				success: "var(--color-success)",
				warning: "var(--color-warning)",
				error: "var(--color-error)",
				lightprimary: "var(--color-lightprimary)",
				lightsecondary: "var(--color-lightsecondary)",
				lightsuccess: "var(--color-lightsuccess)",
				lighterror: "var(--color-lighterror)",
				lightinfo: "var(--color-lightinfo)",
				lightwarning: "var(--color-lightwarning)",
				border: "var(--color-border)",
				bordergray: "var(--color-bordergray)",
				lightgray: "var( --color-lightgray)",
				bodytext: "var( --color-bodytext)",
				//Dark Colors Variables
				dark: "var(--color-dark)",
				link: "var(--color-link)",
				darklink: "var(--color-darklink)",
				darkborder: "var(--color-darkborder)",
				darkgray: "var(--color-darkgray)",
				darkinfo: "var(--color-darkinfo)",
				darksuccess: "var(--color-darksuccess)",
				darkwarning: "var(--color-darkwarning)",
				darkerror: "var(--color-darkerror)",
				darkprimary: "var(--color-darkprimary)",
				darksecondary: "var(--color-darksecondary)",
				primaryemphasis: "var(--color-primary-emphasis)",
				secondaryemphasis: "var(--color-secondary-emphasis)",
				warningemphasis: "var(--color-warning-emphasis)",
				erroremphasis: "var(--color-error-emphasis)",
				successemphasis: "var(--color-success-emphasis)",

			},
		},



	},
	variants: {},
	plugins: [
		require('@tailwindcss/forms')({
			strategy: 'base', // only generate global styles
		}),
		require('@tailwindcss/typography'),
		require('preline/plugin'),
	],
};
