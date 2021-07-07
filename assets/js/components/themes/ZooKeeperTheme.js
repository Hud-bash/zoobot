//REACT
import React from 'react';
import {createMuiTheme, CssBaseline, MuiThemeProvider, responsiveFontSizes} from '@material-ui/core';
import LanaPixelWoff2 from '../themes/fonts/LanaPixel.woff2';

const lanapixel = {
    fontFamily: 'LanaPixel',
    fontStyle: 'normal',
    src: `
        url(${LanaPixelWoff2}) format('woff2')
    `,
};

const theme = createMuiTheme({

    palette: {
        type: 'light',
        secondary: {
            main: '#fdad48',
        },
        primary: {
            main: '#00a99d',
        },

    },
    typography: {
        fontFamily: 'LanaPixel, sans-serif',
        fontSize: 20,
        fontWeightRegular: 'normal',
    },
    overrides: {
        MuiLink: {
            root: {
                textDecoration: 'none',
            },
            underlineHover: {
                textDecoration: 'none',
                "&:hover": {
                    textDecoration: 'none',
                },
            },
        },
        MuiCssBaseline: {
            '@global': {
                '@font-face': [lanapixel],
            },
        },
    },
});

const responsiveTheme = responsiveFontSizes(theme);

const ZooKeeperTheme = (props) => {
    return (
        <MuiThemeProvider theme={responsiveTheme}>
            <CssBaseline />
            {props.children}
        </MuiThemeProvider>
    );
};

export default ZooKeeperTheme;