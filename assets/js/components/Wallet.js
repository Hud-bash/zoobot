import React, {useContext} from 'react';
import {WalletContext} from "../contexts/WalletContext";
import {Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";

function Wallet() {
    const context = useContext(WalletContext);

    return (
        <Table>
            <TableHead>
                <TableRow>
                    <TableCell>Wallet</TableCell>
                    <TableCell>Name</TableCell>
                    <TableCell></TableCell>
                </TableRow>
            </TableHead>
            <TableBody>
                {context.wallets.map(wallet => (
                    <TableRow>
                        <TableCell>{wallet.wallet}</TableCell>
                        <TableCell>{wallet.name}</TableCell>
                        <TableCell>{wallet.animal}</TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export default Wallet;