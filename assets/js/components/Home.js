import React from 'react';
const styles = {
    home: {
        padding: '50px',
        textAlign: 'center',
    }
};
export default class Home extends React.Component {
    render() {
        return <div style={styles.home}>
            <h1>Home Page</h1>

            <p>Yay Home</p>
        </div>;
    }
}
