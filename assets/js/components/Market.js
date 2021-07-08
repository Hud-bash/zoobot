import React, {Fragment, useContext} from 'react';
import {MarketContext} from "../contexts/MarketContext";
import {
    Box,
    Container, Grid, Link,
    makeStyles,
    Table,
    TableBody,
    TableCell,
    TableRow,
} from "@material-ui/core";
import NftTableCell from "./layouts/NftTableCell";
import VisitZooKeeperBanner from "./layouts/VisitZooKeeperBanner";

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        padding: 0,
    },
    img: {
        width: 35,
    },
    sign: {
        height: 600,
        float: "right",
    },
}));


function Market() {
    const context = useContext(MarketContext);
    const classes = useStyles();
    return (
        <Grid container justify={"space-around"}>
            <Grid item>
            <Container maxWidth="sm">
                <Box maxWidth={'80%'} style={{paddingTop: '50px', paddingBottom: '20px',}} alignItems="center" flexGrow="row" >
                    <Link href={'https://www.zookeeper.finance/market'} target={'_blank'}>
                        <VisitZooKeeperBanner />
                    </Link>
                </Box>
                <Table>
                    <TableBody>
                        {context.listings.map(listing => (
                            <TableRow key={listing.nft.nft_id}>
                                <TableCell><NftTableCell nft={listing.nft}/></TableCell>
                                <TableCell>
                                    <Box display="flex">
                                        <Box marginRight={'.5em'} alignContent='center'>{listing.price}</Box>
                                        <Box alignContent='center'><img className={classes.img} src = {listing.currency} alt='token'/></Box>
                                    </Box>
                                </TableCell>
                                <TableCell>{listing.seller.name} {listing.seller.animal}</TableCell>
                                <TableCell>{listing.timestamp}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </Container>
            </Grid>
            <Grid item alignContent={"flex-end"}>
                <Link href={'https://www.zookeeper.finance/market'} target={'_blank'}>
                    <img className={classes.sign} src={'img/market-sign.png'} alt='market-sign'/>
                </Link>
            </Grid>
        </Grid>
    );
}

export default Market;