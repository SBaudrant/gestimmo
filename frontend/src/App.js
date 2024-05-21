import { ChakraProvider } from '@chakra-ui/react';
import { Header } from './components/Header';
import Router from './router';


function App() {
  return (
    <ChakraProvider>
      <Router />
    </ChakraProvider>
  );
}

export default App;
