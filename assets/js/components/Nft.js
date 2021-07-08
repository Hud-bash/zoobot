import React, {useContext} from 'react';
import {NftContext} from "../contexts/NftContext";
import {makeStyles, Table, TableBody, TableCell, TableHead, TableRow} from "@material-ui/core";
import NftTableCell from "./layouts/NftTableCell";

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
            <TableBody>
                {context.nfts.map(nft => (
                    <TableRow>
                        <TableCell><NftTableCell nft={nft}/></TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export default Nft;