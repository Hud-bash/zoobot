import React, {createContext} from 'react';
import axios from "axios";

export const MarketHistoryContext = createContext();

class MarketHistoryContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            count: 0,
            page: 1,
            resultsPerPage: 50,
            sales: [],
            topbuyers: [],
            topsellers: [],
        };
        this.readMarketHistory([this.state.page, this.state.resultsPerPage]);
    }

    //create
    createMarketHistory() {

    }

    //read
    readMarketHistory(props) {
        axios.get('/api/market-history/' + props[0] + '-' + props[1])
            .then(response => {
                this.setState({
                    count: response.data.count,
                    page: props[0],
                    resultsPerPage: props[1],
                    sales: response.data.history,
                    topbuyers: response.data.topbuyer,
                    topsellers: response.data.topseller,
                });
            }).catch(error => {
            console.error(error);
        })
    }
    //update
    updateMarketHistory() {

    }
    //delete
    deleteMarketHistory() {

    }

    render() {
        return (
            <MarketHistoryContext.Provider value={{
                ...this.state,
                createMarketHistory: this.createMarketHistory.bind(this),
                readMarketHistory: this.readMarketHistory.bind(this),
                updateMarketHistory: this.updateMarketHistory.bind(this),
                deleteMarketHistory: this.deleteMarketHistory.bind(this),
            }}>
                {this.props.children}
            </MarketHistoryContext.Provider>
        );
    }
}

export default MarketHistoryContextProvider;