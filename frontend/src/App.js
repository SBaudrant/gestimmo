import { ChakraProvider } from '@chakra-ui/react';
import Router from './router';
import AuthProvider from './providers/AuthProvider';


function App() {
  return (
    <AuthProvider>
      <ChakraProvider>
        <Router />
      </ChakraProvider>
    </AuthProvider>
  );
}

export default App;
