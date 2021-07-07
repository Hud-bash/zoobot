import React, {Fragment, useContext} from 'react';
import {MarketContext} from "../contexts/MarketContext";
import {
    Box,
    Container, Link,
    makeStyles,
    Table,
    TableBody,
    TableCell,
    TableRow,
} from "@material-ui/core";
import NftTableCell from "./layouts/NftTableCell";
import VisitZooKeeperBanner from "./layouts/VisitZooKeeperBanner";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 35,
    },
}));


function Market() {
    const context = useContext(MarketContext);
    const classes = useStyles();
    return (
        <Container maxWidth="md">
            <Box maxWidth={'80%'} style={{paddingTop: '50px', paddingBottom: '20px',}} alignItems="center" flexGrow="row" >
                <Link href={'https://www.zookeeper.finance/market'}>
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
    );
}

export default Market;