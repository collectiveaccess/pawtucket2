import React, { ChangeEventHandler, Dispatch, SetStateAction } from "react";
interface DynamicUrlProps {
    url: string;
    setUrl: Dispatch<SetStateAction<string>>;
    handleLanguage: ChangeEventHandler<HTMLSelectElement>;
}
declare const DynamicUrl: React.FC<DynamicUrlProps>;
export default DynamicUrl;
