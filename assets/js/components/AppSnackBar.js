import {Button, Snackbar, SnackbarContent} from "@material-ui/core";

function AppSnackBar() {
    return (
        <Snackbar autoHideDuration={6000}>
            <SnackbarContent message={"Hello"} />
        </Snackbar>
    );
}

export default AppSnackBar;