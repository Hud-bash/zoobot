import React, {Fragment, useContext} from 'react';
import {MarketContext} from "../contexts/MarketContext";
import {makeStyles, Table, TableBody, TableCell, TableHead, TableRow, useTheme} from "@material-ui/core";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 42,
    },
}));


function Market() {
    const context = useContext(MarketContext);
    const classes = useStyles();
    return (
            <Fragment>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell></TableCell>
                            <TableCell>Price</TableCell>
                            <TableCell></TableCell>
                            <TableCell>Seller</TableCell>
                            <TableCell>Timestamp</TableCell>
                            <TableCell></TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {context.listings.map(listing => (
                            <TableRow>
                                <TableCell align={"center"}>
                                    <img className={classes.img} src = {listing.nftimg} alt='nft' /><br/>
                                    {listing.nft}
                                </TableCell>
                                <TableCell>{listing.price}</TableCell>
                                <TableCell align='left'><img className={classes.img} src = {listing.currency} alt='token'/></TableCell>
                                <TableCell>{listing.seller}</TableCell>
                                <TableCell>{listing.timestamp}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </Fragment>
    );
}

export default Market;