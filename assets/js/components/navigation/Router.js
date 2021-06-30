//REACT
import React from 'react';
//ROUTER
import BrowserRouter from 'react-router-dom/BrowserRouter';
import Route from 'react-router-dom/Route';
import Switch from 'react-router-dom/Switch';
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
    <MarketHistoryContextProvider>
        <Nft/>
    </MarketHistoryContextProvider>
)

const WalletPage = () => (
    <WalletContextProvider>
        <Wallet/>
    </WalletContextProvider>
)

const useStyles = makeStyles((theme) => ({
    divider: theme.mixins.toolbar,
}));

const Router = () => {
    const classes = useStyles();
    return (
            <BrowserRouter>
                <Navigation />
                <div className={classes.divider}/>
                <Switch>
                    <Route exact path="/" component={HomePage} />
                    <Route exact path="/market" component={MarketPage} />
                    <Route exact path="/market-history" component={MarketHistoryPage} />
                    <Route exact path="/chest-history" component={ChestHistoryPage} />
                    <Route exact path="/nfts" component={NftPage} />
                    <Route exact path="/wallets" component={WalletPage} />
                    <Route component={NotFound} />
                </Switch>
            </BrowserRouter>
    );
};

export default Router;