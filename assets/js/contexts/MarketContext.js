import React, {createContext} from 'react';
import axios from "axios";

export const MarketContext = createContext();

class MarketContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            count: 0,
            page: 1,
            resultsPerPage: 50,
            listings: [],
        };
        this.readMarket([this.state.page, this.state.resultsPerPage]);
    }

    //create
    createMarket() {

    }

    //read
    readMarket(props) {
        axios.get('/api/market/' + props[0] + '-' + props[1])
            .then(response => {
                this.setState({
                    count: response.data.count,
                    page: props[0],
                    resultsPerPage: props[1],
                    listings: response.data.market,
                });
            }).catch(error => {
                console.error(error);
        })
    }
    //update
    updateMarket() {

    }
    //delete
    deleteMarket() {

    }

    render() {
        return (
            <MarketContext.Provider value={{
                ...this.state,
                createMarket: this.createMarket.bind(this),
                readMarket: this.readMarket.bind(this),
                updateMarket: this.updateMarket.bind(this),
                deleteMarket: this.deleteMarket.bind(this),
                setMessage: (message) => this.setState({message: message}),
            }}>
                {this.props.children}
            </MarketContext.Provider>
        );
    }
}

export default MarketContextProvider;