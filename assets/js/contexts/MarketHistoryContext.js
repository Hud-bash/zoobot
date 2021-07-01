import React, {createContext} from 'react';
import axios from "axios";

export const MarketHistoryContext = createContext();

class MarketHistoryContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            sales: [],
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
                    sales: response.data,
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