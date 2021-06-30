import React, {useContext} from 'react';
import {MarketHistoryContext} from "../contexts/MarketHistoryContext";
import {Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";

function MarketHistory() {
    const context = useContext(MarketHistoryContext);

    return (
        <Table>
            <TableHead>
                <TableRow>
                    <TableCell>Nft</TableCell>
                    <TableCell>Price</TableCell>
                    <TableCell>""</TableCell>
                    <TableCell>Seller</TableCell>
                    <TableCell>Buyer</TableCell>
                    <TableCell>Timestamp</TableCell>
                </TableRow>
            </TableHead>
            <TableBody>
                {context.sales.map(sale => (
                    <TableRow>
                        <TableCell>{sale.nft}</TableCell>
                        <TableCell>{sale.price}</TableCell>
                        <TableCell>{sale.currency}</TableCell>
                        <TableCell>{sale.seller}</TableCell>
                        <TableCell>{sale.buyer}</TableCell>
                        <TableCell>{sale.timestamp}</TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export default MarketHistory;