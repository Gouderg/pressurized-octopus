import React from "react";
import '../stylesheets/TableShow.css';


const TableShow = ({ }) => {
	const [tables, setTables] = React.useState();

	React.useEffect(() => {
		fetch("http://127.0.0.1:8000/api/tables")      
			.then((response) =>response.json())      
			.then((tables) =>setTables(tables))
            .catch(error => console.log('error', error));		  
	}, []);

    return(
    	 <div id="centre">
    <h1 id="title"> Tables de plongée </h1>
    <br/>
    <br/>
        <div id="gauche_di">
        <div id="decalage">
                
          <h2>Bullman </h2>
           
        </div>
        </div>
        <div class="vl"></div>
        <div id="droite_di">
        <h2 className="graphe"> MN90 </h2>
        
        </div>

</div>

	);
};

export default TableShow;