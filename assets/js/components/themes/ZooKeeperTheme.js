//REACT
import React from 'react';
import {createMuiTheme, CssBaseline, MuiThemeProvider, responsiveFontSizes} from '@material-ui/core';
import {green, red} from "@material-ui/core/colors";
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
        type: 'dark',
        secondary: {
            main: '#fdad48',
        },
        primary: {
            main: '#00a99d',
        },

    },
    typography: {
        fontFamily: 'LanaPixel, sans-serif',
        fontSize: 30,
        fontWeightRegular: 'normal',
    },
    overrides: {
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