import React, {useContext} from 'react';
import {ChestHistoryContext} from "../contexts/ChestHistoryContext";
import {Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";

function ChestHistory() {
    const context = useContext(ChestHistoryContext);

    return (
        <Table>
            <TableHead>
                <TableRow>
                    <TableCell>Nft</TableCell>
                    <TableCell>""</TableCell>
                    <TableCell>Zoo</TableCell>
                    <TableCell>Owner</TableCell>
                    <TableCell>Timestamp</TableCell>
                </TableRow>
            </TableHead>
            <TableBody>
                {context.chesties.map(chest => (
                    <TableRow>
                        <TableCell>{chest.nft}</TableCell>
                        <TableCell>{chest.type}</TableCell>
                        <TableCell>{chest.amount}</TableCell>
                        <TableCell>{chest.owner}</TableCell>
                        <TableCell>{chest.timestamp}</TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export default ChestHistory;