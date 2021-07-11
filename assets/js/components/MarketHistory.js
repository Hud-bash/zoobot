import React, {useContext} from 'react';
import {MarketHistoryContext} from "../contexts/MarketHistoryContext";
import {Box, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TableRow} from "@material-ui/core";
import NftTableCell from "./layouts/NftTableCell";
import Paginator from "./layouts/Paginator";
import {Pagination} from "@material-ui/lab";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 42,
    },
}));

function MarketHistory() {
    const context = useContext(MarketHistoryContext);
    const classes = useStyles();

    const handleChange = (event, newPage) => {
        context.readMarketHistory([newPage, context.resultsPerPage])
    };

    return (
        <Box>
            <Pagination
                variant={"outlined"}
                color={"secondary"}
                count={Math.floor(context.count / context.resultsPerPage)}
                page={context.page}
                onChange={handleChange}
            />
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
                        <TableRow key={sale.nft.nft_id}>
                            <TableCell><NftTableCell nft={sale.nft}/></TableCell>
                            <TableCell>{sale.price}</TableCell>
                            <TableCell align="left"><img className={classes.img} src={sale.currency.logo} alt='currency_symbol'/></TableCell>
                            <TableCell>{sale.seller.name} {sale.seller.animal}</TableCell>
                            <TableCell>{sale.buyer.name} {sale.buyer.animal}</TableCell>
                            <TableCell>{sale.timestamp}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </Box>
    );
}

export default MarketHistory;