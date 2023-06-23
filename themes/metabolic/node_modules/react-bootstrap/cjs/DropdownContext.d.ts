import * as React from 'react';
import { AlignType } from './types';
export declare type DropdownContextValue = {
    align?: AlignType;
};
declare const DropdownContext: React.Context<DropdownContextValue>;
export default DropdownContext;
