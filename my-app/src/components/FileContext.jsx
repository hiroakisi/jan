import { createContext, useState, useContext } from "react";
//Contextオブジェクトの作成
const FileContext = createContext();
//他のコンポーネントでファイルデータを操作するための関数をexport
export function useFileContext() {
  return useContext(FileContext);
}
//TopPage.jsで利用するFileProviderを定義&export
export function FileProvider({ children }) {
  //const [状態変数, 状態を変更するための関数] = useState(状態の初期値);
  const [fileInfo, setFile] = useState({ object: "", base64data: "" });
  const value = {
    fileInfo,
    setFile,
  };
  return <FileContext.Provider value={value}>{children}</FileContext.Provider>;
}
