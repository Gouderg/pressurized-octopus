import React from "react";


const CalculForm = () => {
    return (
        <div>
            <form action="http://127.0.0.1:8000/api/resultForm" method="POST">
                <input type="text" id="test" name="test"></input>
                <button type="submit">Submit</button>
            </form>

        </div>
    );
};

export default CalculForm;