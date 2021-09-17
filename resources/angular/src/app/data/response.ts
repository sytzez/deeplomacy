export interface Response<T extends any> {
    success?: boolean;
    data: T;
}
