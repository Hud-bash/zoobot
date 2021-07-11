import React from 'react';
import {Box, Grid, List, ListItem, makeStyles, Paper, Typography} from "@material-ui/core";

const NftTableCell = (props) => {
    const useStyles = makeStyles((theme) => ({
        img: {
            width: 42,
        },
        root: {
            flexGrow: 1,
        },
        paper: {
            height: 55,
            width: 45,
            padding: 0,
            backgroundColor: "inherit",
        },
    }));

    const classes = useStyles();

    return (
        <Box borderRadius={16} borderColor="primary.main" border={4} width={200} height={160} boxShadow={7}>
            <div align="center">
                <Box>
                    <h4>{props.nft.name}</h4>
                </Box>
                <div className={classes.root}>
                    <Grid container justifyContent="center" spacing={2}>
                        <Grid key={props.nft.boost} item>
                            <Paper className={classes.paper} elevation={0}>
                                <div><img src={'img/rocket24x24.png'}  alt='boost'/></div>
                                <div>{(props.nft.boost * 100).toFixed(2) +"%"}</div>
                            </Paper>
                        </Grid>
                        <Grid key={props.nft.img} item>
                            <Paper className={classes.paper} elevation={0}>
                                <img className={classes.img} src={props.nft.img}  alt='nft'/>
                            </Paper>
                        </Grid>
                        <Grid key={props.nft.reduction} item>
                            <Paper className={classes.paper} elevation={0}>
                                <div><img src={'img/hourglass24x24.png'}  alt='reduction'/></div>
                                <div>{(props.nft.reduction * 100).toFixed(2) +"%"}</div>
                            </Paper>
                        </Grid>
                    </Grid>
                </div>
                <Box marginTop={'.3em'}>
                    <img src=
                             {(() => {
                                 switch (props.nft.category) {
                                     case 1:
                                         return '/img/fruits.png';
                                     case 2:
                                         return 'img/dishes.png';
                                     case 3:
                                         return '/img/sweets.png';
                                     case 4:
                                         return '/img/potions.png';
                                     case 5:
                                         return '/img/magic.png';
                                     case 6:
                                         return '/img/spices.png';
                                     default:
                                         return props.nft.category;
                                 }
                             })()}
                         alt='category'
                    />
                    <img src=
                             {(() => {
                                 switch (props.nft.item) {
                                     case 1:
                                         return '/img/N.png';
                                     case 2:
                                         return '/img/R.png';
                                     case 3:
                                         return '/img/SR.png';
                                     case 4:
                                         return '/img/SSR.png';
                                     case 5:
                                         return '/img/UR.png';
                                     default:
                                         return props.nft.item;
                                 }
                             })()}
                         alt='item'
                    />
                    {(() => {
                     switch (props.nft.level) {
                         case 1:
                             return (
                                 <span>
                                    <img src="img/star18x18.png" alt="level"/>
                                 </span>
                             );
                         case 2:
                             return (
                                 <span>
                                     <img src="img/star18x18.png" alt="level"/><img src="img/star18x18.png" alt="level"/>
                                 </span>
                             );
                         case 3:
                             return (
                                 <span>
                                     <img src="img/star18x18.png" alt="level"/><img src="img/star18x18.png" alt="level"/><img src="img/star18x18.png" alt="level"/>
                                 </span>
                             );
                         case 4:
                             return (
                                 <span>
                                    <img src={'/img/max.png'} alt='level'/>
                                 </span>
                             );
                         default:
                             return props.nft.level;
                     }
                    })()}
                    <Grid container spacing={3}>
                        <Grid item xs />
                        <Grid item xs={6}>
                            Card #{props.nft.nft_id}
                        </Grid>
                        <Grid item xs>
                            {(() => {
                                switch (props.nft.isLocked) {
                                    case 1:
                                        return (
                                        <img src={'img/locked.png'} width={20} align={'left'} alt='locked-nft'/>
                                        );
                                    default:
                                        return '';
                                }
                            })()}
                        </Grid>
                    </Grid>
                </Box>
            </div>
        </Box>
    );
};

export default NftTableCell;