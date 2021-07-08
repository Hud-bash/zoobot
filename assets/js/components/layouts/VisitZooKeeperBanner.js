import React from "react";
import {Box, Grid, Link, makeStyles, Paper, Typography} from "@material-ui/core";

export default function VisitZooKeeperBanner()
{
    const useStyles = makeStyles((theme) => ({
        root: {
            flexGrow: 1,
        },
        paper: {
            padding: theme.spacing(2),
            textAlign: 'center',
            color: theme.palette.text.primary,
            backgroundColor: "inherit",
            boxShadow: "none",
            fontSize: 35,
        },
    }));

    const classes = useStyles();

    return (
        <div>
            <Box borderRadius={50} borderColor="#BD9A7A" border={8}>
                <Grid
                container
                direction="row"
                justify="center"
                alignItems="center"
                >
                    <Grid item>
                        <Paper className={classes.paper}>Buy Now</Paper>
                    </Grid>
                    <Grid item>
                        <Paper className={classes.paper}><img src={"img/zoo_logo.svg"} width="150px" alt="zookeeper_logo"/></Paper>
                    </Grid>
                    <Grid item>
                        <Paper className={classes.paper}>Market</Paper>
                    </Grid>
                </Grid>
            </Box>
        </div>
    );
}