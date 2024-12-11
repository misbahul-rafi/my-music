import { MdError, MdCheckCircle } from "react-icons/md";

interface NotificationProps {
  message: string;
  type: "success" | "error";
}

const Notification = ({ message, type }: NotificationProps) => {
  const isError = type === "error";

  return (
    <div
      className={`fixed right-10 top-20 px-3 py-1 rounded-lg flex items-center ${
        isError ? "bg-[#E4003A]" : "bg-green-400"
      }`}
    >
      <p className="text-center text-md w-[200px]">{message}</p>
      {isError ? <MdError size={30} /> : <MdCheckCircle size={30} />}
    </div>
  );
};

export default Notification;
