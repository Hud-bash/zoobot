import React, {useContext} from 'react';
import {NftContext} from "../contexts/NftContext";
import {Box, makeStyles, Table, TableBody, TableCell, TableRow} from "@material-ui/core";
import NftTableCell from "./layouts/NftTableCell";
import {Pagination} from "@material-ui/lab";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 42,
    },
}));

function Nft() {
    const context = useContext(NftContext);
    const classes = useStyles();

    const handleChange = (event, newPage) => {
        context.readNft([newPage, context.resultsPerPage])
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
                <TableBody>
                    {context.nfts.map(nft => (
                        <TableRow key={nft.nft_id}>
                            <TableCell><NftTableCell nft={nft}/></TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </Box>
    );
}

export default Nft;