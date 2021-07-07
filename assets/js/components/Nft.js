import React, {useContext} from 'react';
import {NftContext} from "../contexts/NftContext";
import {makeStyles, Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 42,
    },
}));

function Nft() {
    const context = useContext(NftContext);
    const classes = useStyles();

    return (
        <Table>
            <TableHead>
                <TableRow>
                    <TableCell/>
                    <TableCell/>
                    <TableCell/>
                    <TableCell/>
                    <TableCell/>
                    <TableCell/>
                    <TableCell/>
                </TableRow>
            </TableHead>
            <TableBody>
                {context.nfts.map(nft => (
                    <TableRow>
                        <TableCell>{nft.isLocked}</TableCell>
                        <TableCell><img className={classes.img} src = {nft.url} alt='nft' /></TableCell>
                        <TableCell>{nft.id}</TableCell>
                        <TableCell>{nft.name}</TableCell>
                        <TableCell><img src = {nft.category} alt='category' /></TableCell>
                        <TableCell><img src = {nft.item} alt='item' /></TableCell>
                        <TableCell>{nft.level}</TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export default Nft;