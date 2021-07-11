import React from 'react';
import {Box, makeStyles} from "@material-ui/core";
import {Pagination} from "@material-ui/lab";

const useStyles = makeStyles((theme) => ({
    root: {
        '& > *': {
            marginTop: theme.spacing(2),
        },
    },
}));

function Paginator(props) {
    const classes = useStyles();

    const [page, setPage] = React.useState(1);

    const handleChange = (event, newPage) => {
        console.log(newPage);
        setPage(newPage);
    };

    return (
        <Box>
            <Pagination
                variant={"outlined"}
                color={"secondary"}
                count={Math.floor(props.count / props.resultsPerPage)}
                page={page}
                onChange={handleChange}
            />
        </Box>
    );
}

export default Paginator;