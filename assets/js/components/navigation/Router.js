//REACT
import React from 'react';
//ROUTER
import {BrowserRouter} from 'react-router-dom';
import {Route} from 'react-router-dom';
import {Switch} from 'react-router-dom';
//MUI
import {makeStyles} from "@material-ui/core";
//CUSTOM
import Navigation from "./Navigation";
import Home from "../Home";
import Market from "../Market";
import MarketHistory from "../MarketHistory";
import ChestHistory from "../ChestHistory";
import NotFound from "../NotFound";
import Nft from "../Nft";
import Wallet from "../Wallet";
import MarketContextProvider from "../../contexts/MarketContext";
import MarketHistoryContextProvider from "../../contexts/MarketHistoryContext";
import ChestHistoryContextProvider from "../../contexts/ChestHistoryContext";
import WalletContextProvider from "../../contexts/WalletContext";
import HomeContextProvider from "../../contexts/HomeContext";
import NftContextProvider from "../../contexts/NftContext";

const HomePage = () => (
    <HomeContextProvider>
        <Home/>
    </HomeContextProvider>
)

const MarketPage = () => (
    <MarketContextProvider>
        <Market/>
    </MarketContextProvider>
)

const MarketHistoryPage = () => (
    <MarketHistoryContextProvider>
        <MarketHistory/>
    </MarketHistoryContextProvider>
)

const ChestHistoryPage = () => (
    <ChestHistoryContextProvider>
        <ChestHistory/>
    </ChestHistoryContextProvider>
)

const NftPage = () => (
    <NftContextProvider>
        <Nft/>
    </NftContextProvider>
)

const WalletPage = () => (
    <WalletContextProvider>
        <Wallet/>
    </WalletContextProvider>
)

const useStyles = makeStyles((theme) => ({
    divider: theme.mixins.toolbar,
    wrapper: {
        marginLeft: "220px",
        marginRight: "20px",
        marginTop: "20px"
    },
}));

const Router = () => {
    const classes = useStyles();
    return (
        <BrowserRouter>
            <Navigation />
            <div className={classes.divider}/>
            <div className={classes.wrapper}>
                <Switch>
                    <Route exact path="/" component={HomePage} />
                    <Route exact path="/market" component={MarketPage} />
                    <Route exact path="/market-history" component={MarketHistoryPage} />
                    <Route exact path="/chest-history" component={ChestHistoryPage} />
                    <Route exact path="/nft" component={NftPage} />
                    <Route exact path="/wallet" component={WalletPage} />
                    <Route component={NotFound} />
                </Switch>
            </div>
        </BrowserRouter>
    );
};

export default Router;