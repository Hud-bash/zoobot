import React, {useContext} from 'react';
import {WalletContext} from "../contexts/WalletContext";
import {Box, Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";
import {Pagination} from "@material-ui/lab";

function Wallet() {
    const context = useContext(WalletContext);

    const handleChange = (event, newPage) => {
        context.readWallet([newPage, context.resultsPerPage])
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
                        <TableCell>Wallet</TableCell>
                        <TableCell>Name</TableCell>
                        <TableCell/>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {context.wallets.map(wallet => (
                        <TableRow key={wallet.wallet}>
                            <TableCell>{wallet.wallet}</TableCell>
                            <TableCell>{wallet.name}</TableCell>
                            <TableCell>{wallet.animal}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </Box>
    );
}

export default Wallet;