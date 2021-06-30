import React, {Fragment, useContext} from 'react';
import {MarketContext} from "../contexts/MarketContext";
import {Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";

function Market() {
    const context = useContext(MarketContext);
    return (
            <Fragment>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell>Nft</TableCell>
                            <TableCell>Price</TableCell>
                            <TableCell>""</TableCell>
                            <TableCell>Seller</TableCell>
                            <TableCell>Timestamp</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {context.listings.map(listing => (
                            <TableRow>
                                <TableCell>{listing.nft}</TableCell>
                                <TableCell>{listing.price}</TableCell>
                                <TableCell>{listing.currency}</TableCell>
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