import React, {createContext} from 'react';
import axios from "axios";

export const ChestHistoryContext = createContext();

class ChestHistoryContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            count: 0,
            page: 1,
            resultsPerPage: 50,
            chesties: [],
            topwallets: [],
        };
        this.readChestHistory([this.state.page, this.state.resultsPerPage]);
    }

    //create
    createChestHistory()
    {
    }

    //read
    readChestHistory(props)
    {
        axios.get('/api/chest-history/' + props[0] + '-' + props[1])
            .then(response => {
                this.setState({
                    count: response.data.count,
                    page: props[0],
                    resultsPerPage: props[1],
                    chesties: response.data.history,
                    topwallets: response.data.topchesties,
                });
            }).catch(error => {
            console.error('ERROR FROM readChestHistory()');
            console.error(error);
        })
    }
    //update
    updateChestHistory()
    {
    }
    //delete
    deleteChestHistory()
    {
    }

    render() {
        return (
            <ChestHistoryContext.Provider value={{
                ...this.state,
                readChestHistory: this.readChestHistory.bind(this),
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