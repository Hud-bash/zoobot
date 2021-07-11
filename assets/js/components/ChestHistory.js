import React, {useContext} from 'react';
import {ChestHistoryContext} from "../contexts/ChestHistoryContext";
import {Box, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TableRow} from "@material-ui/core";
import Paginator from "./layouts/Paginator";
import NftTableCell from "./layouts/NftTableCell";
import {Pagination} from "@material-ui/lab";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 42,
    },
}));

function ChestHistory() {
    const context = useContext(ChestHistoryContext);
    const classes = useStyles();

    const handleChange = (event, newPage) => {
        context.readChestHistory([newPage, context.resultsPerPage])
    };

    return (
        <Box width={'50%'}>
            <Pagination
                variant={"outlined"}
                color={"secondary"}
                count={Math.floor(context.count / context.resultsPerPage)}
                page={context.page}
                onChange={handleChange}
            />
            <Table>
                <TableBody>
                {context.chesties.map(chest => (
                    <TableRow key={chest.id}>
                        <TableCell>
                            {(() => {
                                if (chest.nft !== "")
                                {
                                    return <NftTableCell nft={chest.nft} />
                                }
                            })()}
                        </TableCell>
                        <TableCell>
                            <img src=
                                     {(() => {
                                         if (chest.type.includes("ilver"))
                                         {
                                             if(chest.nft === "")
                                             {
                                                 return '/img/silverboxfail42x42.png';
                                             }
                                             else
                                             {
                                                 return '/img/silverbox42x42.png';
                                             }
                                         }
                                         else
                                         {
                                             return '/img/goldenbox42x42.png';
                                         }
                                     })()}
                                 alt='box-type'
                            />
                        </TableCell>
                        <TableCell>{chest.amount}</TableCell>
                        <TableCell>{chest.wallet.name} {chest.wallet.animal}</TableCell>
                        <TableCell>{chest.timestamp}</TableCell>
                    </TableRow>
                    ))}
                </TableBody>
            </Table>
        </Box>
    );
}

export default ChestHistory;