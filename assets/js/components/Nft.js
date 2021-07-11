import React, {useContext} from 'react';
import {NftContext} from "../contexts/NftContext";
import {ImageList, ImageListItem, makeStyles} from "@material-ui/core";
import NftTableCell from "./layouts/NftTableCell";
import {Pagination, PaginationItem} from "@material-ui/lab";

const useStyles = makeStyles((theme) => ({
    img: {
        width: 42,
    },
    imgList: {
        width: "auto",
        height: "auto"
    },
    paginator: {
        paddingBottom: "20px",
    },
    paginatorItem: {
        outline: "none",
        "&:hover": {
            backgroundColor: theme.palette.action.hover,
        },
        "&.MuiPaginationItem-page": {
            "&.Mui-selected": {
                backgroundColor: theme.palette.secondary.main,
                "&:hover": {
                    backgroundColor: theme.palette.secondary.main,
                },
            },
        },
        "&.Mui-focusVisible": {
            backgroundColor: 'transparent',
            outline: "none",
            "&:hover": {
                backgroundColor: 'transparent',
            },
        },
    },
}));

function Nft() {
    const context = useContext(NftContext);
    const classes = useStyles();

    const handleChange = (event, newPage) => {
        context.readNft([newPage, context.resultsPerPage])
    };

    return (
        <div>
            <Pagination
                className={classes.paginator}
                color={'secondary'}
                count={Math.floor(context.count / context.resultsPerPage)}
                page={context.page}
                onChange={handleChange}
                siblingCount={5}
                boundaryCount={2}
                renderItem={(item)=> <PaginationItem {...item}
                                                     className={classes.paginatorItem} />}
            />
            <ImageList cols={5} className={classes.imgList}>
                {context.nfts.map(nft => (
                    <ImageListItem key={nft.nft_id}>
                        <NftTableCell nft={nft}/>
                    </ImageListItem>
                ))}
            </ImageList>
        </div>
    );
}

export default Nft;