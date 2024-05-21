import { ChakraProvider, Container } from '@chakra-ui/react';
import { Header } from './components/Header';

function App() {
  return (
    <ChakraProvider>
      <Header/>
      <Container/>
    </ChakraProvider>
  );
}

export default App;
