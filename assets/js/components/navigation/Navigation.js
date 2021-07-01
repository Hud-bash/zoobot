//REACT
import React from 'react';
import {NavLink} from 'react-router-dom';
//MUI
import {
    AppBar, Box,
    Drawer, Link,
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
            link: '/wallet',
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
            backgroundColor: "white",
        },
        drawerContainer: {
            overflow: 'auto',
        },
        link: {
            color: "black",
            textDecoration: 'none',
            "&:hover": {
                textDecoration: 'none',
                color: "black",
            },
        },
        navButton: {
            textDecoration: 'none',
            color: "black",
            '&:hover': {
            backgroundColor: '#fdad48',
            color: "black",
            },
        },
        active: {
            textDecoration: "none",
            backgroundColor: '#fdad48',
            color: "black"
        }
    }));

    const classes = useStyles();

    return (
        <div className={classes.root} >
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
                            <ListItem
                                button
                                className={classes.navButton}
                                activeClassName={classes.active}
                                component={NavLink}
                                to={prop.link}
                                key={prop.text}
                            >
                                <ListItemText>{prop.text}</ListItemText>
                            </ListItem>
                        ))}
                    </List>
                </div>
            </Drawer>
        </div>
    );
}

export default Navigation;