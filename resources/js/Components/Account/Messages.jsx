import React, { useState, useEffect, useRef } from 'react';
import { Link, router } from '@inertiajs/react';
import { FiSend, FiMessageSquare, FiChevronLeft } from 'react-icons/fi';
import toast from 'react-hot-toast';

export default function Messages({ conversations = [], currentUser }) {
    const [selectedUserId, setSelectedUserId] = useState(null);
    const [messages, setMessages] = useState([]);
    const [newMessage, setNewMessage] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const messagesEndRef = useRef(null);

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    };

    useEffect(() => {
        scrollToBottom();
    }, [messages, selectedUserId]);

    const loadConversation = async (userId) => {
        setIsLoading(true);
        setSelectedUserId(userId);
        try {
            const response = await fetch(`/messages/${userId}`);
            const data = await response.json();
            setMessages(data.messages || []);
        } catch (error) {
            console.error(error);
            toast.error('Failed to load messages');
            setMessages([]);
        } finally {
            setIsLoading(false);
        }
    };

       const sendMessage = async (e) => {
        e.preventDefault();
        if (!newMessage.trim() || !selectedUserId) return;
        const tempId = Date.now();
        const tempMessage = {
            id: tempId,
            sender_id: currentUser.id,
            receiver_id: selectedUserId,
            message: newMessage,
            created_at: new Date().toISOString(),
            sender: { name: currentUser.name, image_url: currentUser.image_url }
        };
        
        setMessages(prev => [...prev, tempMessage]);
        const messageToSend = newMessage;
        setNewMessage('');
        scrollToBottom();
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch('/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: selectedUserId,
                    message: messageToSend,
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error('Failed to send message');
            }

        } catch (error) {
            console.error("Message send error:", error);
            toast.error('Failed to send message');
            setMessages(prev => prev.filter(m => m.id !== tempId));
            setNewMessage(messageToSend);
        }
    };

    const activeConversation = conversations.find(c => c.user?.id === selectedUserId);

    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-slate-900">Messages</h1>
            <div className="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex h-[600px]">
                

                <div className={`w-full md:w-1/3 border-r border-slate-200 flex flex-col ${selectedUserId ? 'hidden md:flex' : 'flex'}`}>
                    <div className="p-4 border-b border-slate-200 bg-slate-50">
                        <h2 className="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <FiMessageSquare className="text-brand" /> Conversations
                        </h2>
                    </div>
                    
                    <div className="flex-1 overflow-y-auto">
                        {conversations.length > 0 ? (
                            conversations.map((conv, idx) => (
                                <div 
                                    key={idx}
                                    onClick={() => loadConversation(conv.user.id)}
                                    className={`p-4 border-b border-slate-100 cursor-pointer hover:bg-slate-50 transition-colors flex gap-3 ${selectedUserId === conv.user.id ? 'bg-brand/5 border-l-4 border-l-brand' : ''}`}
                                >
                                    <img 
                                        src={conv.user.image_url || `https://ui-avatars.com/api/?name=${conv.user.name}&background=0d9488&color=fff`} 
                                        alt={conv.user.name} 
                                        className="w-12 h-12 rounded-full object-cover flex-shrink-0 bg-slate-100" 
                                    />
                                    <div className="flex-1 min-w-0">
                                        <div className="flex justify-between items-start">
                                            <h4 className="font-semibold text-slate-800 text-sm truncate">{conv.user.name}</h4>
                                            <span className="text-xs text-slate-400 whitespace-nowrap">
                                                {new Date(conv.created_at).toLocaleDateString()}
                                            </span>
                                        </div>
                                        
                                        {conv.listing && (
                                            <p className="text-[10px] text-brand font-medium truncate mb-1">
                                                Re: {conv.listing.title}
                                            </p>
                                        )}
                                        
                                        <p className={`text-sm truncate ${conv.unread_count > 0 ? 'font-semibold text-slate-900' : 'text-slate-500'}`}>
                                            {conv.latest_message}
                                        </p>
                                    </div>
                                    
                                    {conv.unread_count > 0 && (
                                        <div className="flex-shrink-0 self-center">
                                            <span className="bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full">
                                                {conv.unread_count > 9 ? '9+' : conv.unread_count}
                                            </span>
                                        </div>
                                    )}
                                </div>
                            ))
                        ) : (
                            <div className="p-8 text-center text-slate-500">
                                <FiMessageSquare className="mx-auto text-3xl mb-2 text-slate-300" />
                                <p>No conversations yet.</p>
                                <p className="text-xs mt-2 text-slate-400">Book a property or host to start chatting!</p>
                            </div>
                        )}
                    </div>
                </div>

    
                <div className={`flex-1 flex flex-col ${selectedUserId ? 'flex' : 'hidden md:flex'}`}>
                    {selectedUserId && activeConversation ? (
                        <>
           
                            <div className="p-4 border-b border-slate-200 flex items-center gap-3 bg-white">
                                <button onClick={() => setSelectedUserId(null)} className="md:hidden text-slate-500 hover:text-slate-700">
                                    <FiChevronLeft className="w-6 h-6" />
                                </button>
                                <img 
                                    src={activeConversation.user.image_url || `https://ui-avatars.com/api/?name=${activeConversation.user.name}&background=0d9488&color=fff`} 
                                    alt={activeConversation.user.name} 
                                    className="w-10 h-10 rounded-full object-cover bg-slate-100" 
                                />
                                <div>
                                    <h3 className="font-bold text-slate-800 text-sm">{activeConversation.user.name}</h3>
                                    {activeConversation.listing && (
                                        <Link href={`/property/${activeConversation.listing.slug}`} className="text-xs text-brand hover:underline truncate block max-w-[200px]">
                                            {activeConversation.listing.title}
                                        </Link>
                                    )}
                                </div>
                            </div>

         
                            <div className="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50">
                                {isLoading ? (
                                    <div className="flex items-center justify-center h-full">
                                        <div className="text-center text-slate-500">
                                            <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-brand mx-auto mb-2"></div>
                                            Loading messages...
                                        </div>
                                    </div>
                                ) : messages.length > 0 ? (
                                    messages.map((msg) => {
                                        const isMe = msg.sender_id === currentUser.id;
                                        return (
                                            <div key={msg.id} className={`flex ${isMe ? 'justify-end' : 'justify-start'}`}>
                                                <div className={`max-w-[75%] rounded-2xl px-4 py-2.5 shadow-sm ${isMe ? 'bg-brand text-white rounded-br-none' : 'bg-white text-slate-800 border border-slate-200 rounded-bl-none'}`}>
                                                    <p className="text-sm leading-relaxed break-words">{msg.message}</p>
                                                    <p className={`text-[10px] mt-1 text-right ${isMe ? 'text-brand-100' : 'text-slate-400'}`}>
                                                        {new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                                    </p>
                                                </div>
                                            </div>
                                        );
                                    })
                                ) : (
                                    <div className="flex flex-col items-center justify-center h-full text-slate-400">
                                        <FiMessageSquare className="w-12 h-12 mb-2 text-slate-300" />
                                        <p className="text-sm">No messages yet. Start the conversation!</p>
                                    </div>
                                )}
                                <div ref={messagesEndRef} />
                            </div>


                            <form onSubmit={sendMessage} className="p-4 border-t border-slate-200 bg-white flex gap-2">
                                <input
                                    type="text"
                                    value={newMessage}
                                    onChange={(e) => setNewMessage(e.target.value)}
                                    placeholder="Type a message..."
                                    className="flex-1 border border-slate-300 rounded-full px-4 py-2.5 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-all"
                                />
                                <button 
                                    type="submit" 
                                    disabled={!newMessage.trim() || isLoading} 
                                    className="bg-brand text-white p-2.5 rounded-full hover:bg-brand/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center w-11 h-11"
                                >
                                    <FiSend className="w-5 h-5" />
                                </button>
                            </form>
                        </>
                    ) : (
                        <div className="flex-1 flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                            <FiMessageSquare className="w-16 h-16 mb-4 text-slate-300" />
                            <p className="text-lg font-medium text-slate-600">Select a conversation to start chatting</p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}