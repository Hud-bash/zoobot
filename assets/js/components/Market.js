import React, {Fragment, useContext} from 'react';
import {MarketContext} from "../contexts/MarketContext";
import {
    Box,
    Container, Grid, Link,
    makeStyles,
    Table,
    TableBody,
    TableCell, TableContainer,
    TableRow,
} from "@material-ui/core";
import NftTableCell from "./layouts/NftTableCell";
import VisitZooKeeperBanner from "./layouts/VisitZooKeeperBanner";
import {Pagination} from "@material-ui/lab";

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

    const handleChange = (event, newPage) => {
        context.readMarket([newPage, context.resultsPerPage])
    };

    return (
        <Grid container justifyContent={"space-around"}>
            <Grid item>
            <Container maxWidth="sm">
                <Pagination
                    variant={"outlined"}
                    color={"secondary"}
                    count={Math.floor(context.count / context.resultsPerPage)}
                    page={context.page}
                    onChange={handleChange}
                />
                <Table>
                    <TableBody>
                        {context.listings.map(listing => (
                            <TableRow key={listing.nft.nft_id}>
                                <TableCell><NftTableCell nft={listing.nft}/></TableCell>
                                <TableCell>
                                    <Box display="flex">
                                        <Box marginRight={'.5em'} alignContent='center'>{listing.price}</Box>
                                        <Box alignContent='center'><img className={classes.img} src = {listing.currency.logo} alt='token'/></Box>
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
            <Grid item>
                <Link href={'https://www.zookeeper.finance/market'} target={'_blank'}>
                    <img className={classes.sign} src={'img/market-sign.png'} alt='market-sign'/>
                </Link>
            </Grid>
        </Grid>
    );
}

export default Market;