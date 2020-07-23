import * as React from "react";
import { Layout } from 'react-admin';
import Menu from './menu';

const CustomLayout = (props) => <Layout {...props} menu={Menu} />;

export default CustomLayout;