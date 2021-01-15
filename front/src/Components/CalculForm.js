import React from "react";


const CalculForm = () => {
    return (
        <div>
            <form action="http://127.0.0.1:8000/api/resultForm" method="POST">
                <input type="text" id="test" name="test"></input>
                <input type="radio" name= "contenance" value="9" checked> 9L <br>
				<input type="radio" name= "contenance" value="12">12L <br>
				<input type="radio" name= "contenance" value="15">15L <br>
				<input type="radio" name= "contenance" value="18">18L 

                <button type="submit">Submit</button>
            </form>

        </div>
    );
};

export default CalculForm;