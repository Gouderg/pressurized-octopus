import './App.css';
import {
	Link,
	Route,
	BrowserRouter as Router,
	Switch
  } from "react-router-dom";
import logo from './img/logo.png'

function App() {

	return (
		<Router>
			<div className="App">
				<header className="App-header">
					<img src={logo} className="App-logo" alt="logo" />
					<h2>Pressurized Octopus</h2>
					<nav>
						<ul> 
							{/*<li><Link to="/">Home</Link></li>*/}
							<li><Link to="/">Table</Link></li>
							<li><Link to="/">Calcul</Link></li>
						</ul>
					</nav>
				</header>
			</div>
		</Router>
  	);
}

export default App;
