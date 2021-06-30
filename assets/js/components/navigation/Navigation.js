//REACT
import React from 'react';
import {Link} from 'react-router-dom';
//MUI
import {
    AppBar,
    Drawer,
    List,
    ListItem,
    ListItemText,
    makeStyles,
    Toolbar,
    Typography
} from "@material-ui/core";


const Navigation = () => {

    const drawerItems = [
        {
            text: 'Market',
            link: '/market',
        },
        {
            text: 'Market History',
            link: '/market-history',
        },
        {
            text: 'NFT Discoveries',
            link: '/nft',
        },
        {
            text: 'ZooKeepers',
            link: '/wallets',
        },
        {
            text: 'Chesties!',
            link: '/chest-history',
        }
    ]

    const drawerWidth = 200;

    const useStyles = makeStyles((theme) => ({
        root: {
            display: 'flex',
        },
        appBar: {
            zIndex: theme.zIndex.drawer + 1,
        },
        drawer: {
            width: drawerWidth,
            flexShrink: 0,
        },
        drawerPaper: {
            width: drawerWidth,
        },
        drawerContainer: {
            overflow: 'auto',
        },
        content: {
            flexGrow: 1,
            padding: theme.spacing(3),
        },
        link: {
            textDecoration: "none",
        },
    }));

    const classes = useStyles();

    return (
        <div className={classes.root}>
            <AppBar position="fixed" className={classes.appBar}>
                <Toolbar>
                    <Typography variant="h6">ZooHub</Typography>
                </Toolbar>
            </AppBar>
            <Drawer
                className={classes.drawer}
                variant="permanent"
                classes={{
                    paper: classes.drawerPaper,
                }}
            >
                <Toolbar />
                <div className={classes.drawerContainer}>
                    <List>
                        {drawerItems.map(prop => (
                            <Link className={classes.link} to={prop.link} key={prop.text}>
                                <ListItem>
                                    <ListItemText>{prop.text}</ListItemText>
                                </ListItem>
                            </Link>
                        ))}
                    </List>
                </div>
            </Drawer>
        </div>
    );
}

export default Navigation;