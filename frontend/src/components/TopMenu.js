import {
    Box,
    Flex,
    Menu,
    MenuGroup,
    MenuItem,
    Spacer,
} from '@chakra-ui/react'

export default function TopMenu() {



    return (
        <Menu>
            {/* @todo Add if with isLoggedIn() */}
            <Flex direction={'row'} width='100%'>
                {/* <Flex grow={1}> */}
                    <MenuItem>Home</MenuItem>
                    <MenuItem>Mes biens</MenuItem>
                    <MenuItem>Fiscalité</MenuItem>
                {/* </Flex> */}
                <Spacer />
                {/* <Flex> */}
                    <MenuItem>Mon compte</MenuItem>
                {/* </Flex> */}
            </Flex>

        </Menu>
    )

}