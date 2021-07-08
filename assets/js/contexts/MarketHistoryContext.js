import React, {createContext} from 'react';
import axios from "axios";

export const MarketHistoryContext = createContext();

class MarketHistoryContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            count: 0,
            sales: [],
            topbuyers: [],
            topsellers: [],
        };
        this.readMarketHistory();
    }

    //create
    createMarketHistory() {

    }

    //read
    readMarketHistory() {
        axios.get('/api/market-history')
            .then(response => {
                this.setState({
                    count: response.data.count,
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
                updateMarketHistory: this.updateMarketHistory.bind(this),
                deleteMarketHistory: this.deleteMarketHistory.bind(this),
            }}>
                {this.props.children}
            </MarketHistoryContext.Provider>
        );
    }
}

export default MarketHistoryContextProvider;