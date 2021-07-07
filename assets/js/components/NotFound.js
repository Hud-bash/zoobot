import React from 'react';
import {Box, Button, Typography} from "@material-ui/core";
import {Link} from "react-router-dom";

const NotFound = () => {
    return (
        <Box paddingTop='20px' textAlign="center">
            <Typography variant="h1">Page Not Found 404</Typography>
            <Link style={{textDecoration: 'none'}} to="/">
                <Button color="primary" variant="contained" size="large">Go Back To Home Page</Button>
            </Link>
        </Box>
    );
};

export default NotFound;