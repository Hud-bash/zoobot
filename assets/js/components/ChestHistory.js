import React, {useContext} from 'react';
import {ChestHistoryContext} from "../contexts/ChestHistoryContext";
import {makeStyles, Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";
import Paginator from "./layouts/Paginator";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 42,
    },
}));

function ChestHistory() {
    const context = useContext(ChestHistoryContext);
    const classes = useStyles();

    return (
        <Table>
            <Paginator count={context.count} />
            <TableHead>
                <TableRow>
                    <TableCell>Nft</TableCell>
                    <TableCell/>
                    <TableCell>Zoo</TableCell>
                    <TableCell>Owner</TableCell>
                    <TableCell/>
                    <TableCell>Timestamp</TableCell>
                </TableRow>
            </TableHead>
            <TableBody>
                {context.chesties.map(chest => (
                    <TableRow>
                        <TableCell></TableCell>
                        <TableCell><img className={classes.img} src = {chest.type} alt='chest_type' /></TableCell>
                        <TableCell>{chest.amount}</TableCell>
                        <TableCell>{chest.wallet.name}</TableCell>
                        <TableCell>{chest.wallet.animal}</TableCell>
                        <TableCell>{chest.timestamp}</TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export default ChestHistory;