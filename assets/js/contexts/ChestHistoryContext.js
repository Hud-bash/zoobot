import React, {createContext} from 'react';
import axios from "axios";

export const ChestHistoryContext = createContext();

class ChestHistoryContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            chesties: [],
        };
        this.readChestHistory();
    }

    //create
    createChestHistory() {

    }

    //read
    readChestHistory() {
        axios.get('/api/chest-history')
            .then(response => {
                this.setState({
                    chesties: response.data.history,
                });
            }).catch(error => {
            console.error(error);
        })
    }
    //update
    updateChestHistory() {

    }
    //delete
    deleteChestHistory() {

    }

    render() {
        return (
            <ChestHistoryContext.Provider value={{
                ...this.state,
                createChestHistory: this.createChestHistory.bind(this),
                updateChestHistory: this.updateChestHistory.bind(this),
                deleteChestHistory: this.deleteChestHistory.bind(this),
            }}>
                {this.props.children}
            </ChestHistoryContext.Provider>
        );
    }
}

export default ChestHistoryContextProvider;