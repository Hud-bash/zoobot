import React, {useContext} from 'react';
import {NftContext} from "../contexts/NftContext";
import {Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";

function Nft() {
    const context = useContext(NftContext);

    return (
        <Table>
            <TableHead>
                <TableRow>
                    <TableCell>isLocked</TableCell>
                    <TableCell>url</TableCell>
                    <TableCell>id</TableCell>
                    <TableCell>Name</TableCell>
                    <TableCell>Category</TableCell>
                    <TableCell>Item</TableCell>
                    <TableCell>Level</TableCell>
                </TableRow>
            </TableHead>
            <TableBody>
                {context.nfts.map(nft => (
                    <TableRow>
                        <TableCell>{nft.isLocked}</TableCell>
                        <TableCell>{nft.url}</TableCell>
                        <TableCell>{nft.id}</TableCell>
                        <TableCell>{nft.name}</TableCell>
                        <TableCell>{nft.category}</TableCell>
                        <TableCell>{nft.item}</TableCell>
                        <TableCell>{nft.level}</TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export default Nft;