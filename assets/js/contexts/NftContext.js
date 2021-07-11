import React, {createContext} from 'react';
import axios from "axios";

export const NftContext = createContext();

class NftContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            count: 0,
            page: 1,
            resultsPerPage: 50,
            nfts: [],
        };
        this.readNft([this.state.page, this.state.resultsPerPage]);
    }

    //create
    createNft() {

    }

    //read
    readNft(props) {
        axios.get('/api/nft/' + props[0] + '-' + props[1])
            .then(response => {
                this.setState({
                    count: response.data.count,
                    page: props[0],
                    resultsPerPage: props[1],
                    nfts: response.data.nfts,
                });
            }).catch(error => {
            console.error(error);
        })
    }
    //update
    updateNft() {

    }
    //delete
    deleteNft() {

    }

    render() {
        return (
            <NftContext.Provider value={{
                ...this.state,
                createNft: this.createNft.bind(this),
                readNft: this.readNft.bind(this),
                updateNft: this.updateNft.bind(this),
                deleteNft: this.deleteNft.bind(this),
            }}>
                {this.props.children}
            </NftContext.Provider>
        );
    }
}

export default NftContextProvider;