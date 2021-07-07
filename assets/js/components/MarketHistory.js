import React, {useContext} from 'react';
import {MarketHistoryContext} from "../contexts/MarketHistoryContext";
import {makeStyles, Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 42,
    },
}));

function MarketHistory() {
    const context = useContext(MarketHistoryContext);
    const classes = useStyles();

    return (
        <Table>
            <TableHead>
                <TableRow>
                    <TableCell>Nft</TableCell>
                    <TableCell>Price</TableCell>
                    <TableCell/>
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
                        <TableCell align="left"><img className={classes.img} src={sale.currency} alt='currency_symbol'/></TableCell>
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