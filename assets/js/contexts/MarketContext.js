import React, {createContext} from 'react';
import axios from "axios";

export const MarketContext = createContext();

class MarketContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            listings: [],
        };
        this.readMarket();
    }

    //create
    createMarket() {

    }

    //read
    readMarket() {
        axios.get('/api/market')
            .then(response => {
                this.setState({
                    listings: response.data,
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