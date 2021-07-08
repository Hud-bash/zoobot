import React from 'react';
import {makeStyles} from "@material-ui/core";
import {Pagination} from "@material-ui/lab";

const skip = 100;
const page = 1;

const useStyles = makeStyles((theme) => ({
    root: {
        '& > *': {
            marginTop: theme.spacing(2),
        },
    },
}));

function Paginator(props) {
    const classes = useStyles();

    return (
        <div className={classes.root}>
            <Pagination count={Math.floor(props.count / skip)} variant="outlined" color="secondary" page={props.page}/>
        </div>
    );
}

export default Paginator;