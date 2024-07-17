'use client'

import {
    Box,
    Stack,
    Input,
    Button,
    FormControl,
} from '@chakra-ui/react'
import { Component, useState } from 'react'
import { json } from 'react-router-dom';

const LoginForm = () => {
    
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    async function sendLogin(){
        const datas = { username: username, password: password };

        const response = await fetch(process.env.REACT_APP_BACKEND_URL + "/users/username", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datas)
        })

        debugger
        return response.json();
    }

    const onSubmit = (event) => {
        setIsLoading(true)
        sendLogin()
            .then(()=>{
                setUsername('')
                setPassword('')
            })
            .catch(error => {
                console.log(error)
            })
            .finally(() => {
                setIsLoading(false);
            })

        event.preventDefault();
    }

    return (

        <Box mt={10} >
            <form onSubmit={onSubmit}>
                <Stack spacing={4}>
                    <FormControl>
                        <Input
                            placeholder="Email ou identifiant"
                            bg={'gray.100'}
                            border={0}
                            color={'gray.500'}
                            _placeholder={{
                                color: 'gray.500',
                            }}
                            value={username}
                            onChange={e => setUsername(e.target.value)}
                        />
                    </FormControl>
                    <Input
                        placeholder={"Mot de passe"}
                        bg={'gray.100'}
                        border={0}
                        color={'gray.500'}
                        _placeholder={{
                            color: 'gray.500',
                        }}
                        type="password"
                        value={password}
                        onChange={e => setPassword(e.target.value)}
                    />
                </Stack>
                <Button
                    fontFamily={'heading'}
                    type='submit'
                    mt={8}
                    w={'full'}
                    bgGradient="linear(to-r, red.400,pink.400)"
                    color={'white'}
                    _hover={{
                        bgGradient: 'linear(to-r, red.400,pink.400)',
                        boxShadow: 'xl',
                    }}
                    isLoading={isLoading}>
                    Submit
                </Button>
            </form>
        </Box>

    )
    
}

export default LoginForm